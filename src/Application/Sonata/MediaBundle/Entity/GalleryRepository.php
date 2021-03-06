<?php

namespace Application\Sonata\MediaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Sonata\MediaBundle\Provider\Pool;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * PostAssetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GalleryRepository extends EntityRepository
{
    public function getAllSubGalleriesMedia( Gallery $mainCategory, $returnParent = false)
    {
        $em = $this->getEntityManager();
        $mainId = $mainCategory->getId();
        $galleries = $this->getSubGalleries($mainId);
        $media = [];
        $galleryNames = [];

        $mediaQuery = $em->createQuery('SELECT ghm FROM ApplicationSonataMediaBundle:GalleryHasMedia ghm WHERE ghm.gallery IN(:subgalleries) AND ghm.enabled=1')
                         ->setParameter('subgalleries', $galleries);

        foreach ($mediaQuery->iterate() as $key => $value) {
            $media[] = array('media'=>$value[0]->getMedia(),
                             'name'=>$value[0]->getGallery()->getName(),
                            );
            if(!in_array($value[0]->getGallery()->getName(), $galleryNames)) {
                array_push($galleryNames,$value[0]->getGallery()->getName());
            }
        }

        return array('media'=>$media,'nameMedia'=>$galleryNames);
    }

    public function getAjaxMediaByCategory(Gallery $mainCategory, Gallery $subCategory, Pool $pool, $round=1, $limit=5)
    {
        $galleryId = $mainCategory->getId();
        $subGaleryId = $subCategory->getId();
        $offset = ($round-1)*$limit;
        $em = $this->getEntityManager();
        $ajaxGallery = [];
        $subGalleryQuery = $em->createQuery('SELECT sg.id FROM DJBlogBundle:SubGallery sg WHERE sg.parentGallery=:parent AND sg.childrenGallery=:child' )
                            ->setParameter('parent',$galleryId)
                            ->setParameter('child',$subGaleryId)
                            ->setMaxResults(1);

        if($subGalleryQuery->getArrayResult() ) {
                $rsm = new ResultSetMapping();
                $rsm->addEntityResult('Application\Sonata\MediaBundle\Entity\GalleryHasMedia', 'c');
                $rsm->addFieldResult('c', 'id', 'id');
                $rsm->addFieldResult('c', 'created_at', 'createdAt');
                $rsm->addMetaResult('c','media_id', 'media_id');
                $rsm->addMetaResult('c','gallery_id', 'gallery_id');

                $query = $this->getEntityManager()->createNativeQuery("SELECT mgm.id, mgm.media_id, mgm.gallery_id  FROM media__gallery_media mgm  INNER JOIN "
                        . "(SELECT id FROM media__gallery_media  WHERE gallery_id = ? AND enabled=? ORDER BY position LIMIT ? OFFSET ?) as small_tbl"
                        . " using (id)", $rsm);
                $query->setParameter(1, $subGaleryId);
                $query->setParameter(2, true);
                $query->setParameter(3, $limit);
                $query->setParameter(4, $offset);

            foreach ($query->getResult() as $key => $value) {
                $provider = $pool->getProvider($value->getMedia()->getProviderName());
                $format = $provider->getFormatName($value->getMedia(), $value->getMedia()->getFormat());
                $helperProperties = $provider->getHelperProperties($value->getMedia(),'gallery_'. $value->getMedia()->getFormat());
                $ajaxGallery['data'][$key]['name'] = $value->getMedia()->getName();
                $ajaxGallery['data'][$key]['width'] = $helperProperties['width'];
                $ajaxGallery['data'][$key]['height'] = $helperProperties['height'];
                $ajaxGallery['data'][$key]['url'] = $provider->generatePublicUrl($value->getMedia(), $format);
                $ajaxGallery['data'][$key]['format'] = str_replace(' ','-', strtolower($value->getGallery()->getName()) );
            }

            if(!array_key_exists('data', $ajaxGallery)) {
                $ajaxGallery['data'] = false;
            }
            $ajaxGallery['page'] = $round;
        }

        return $ajaxGallery;
    }

    public function getSubGalleries($mainGalleryId)
    {
        $em = $this->getEntityManager();
        $subGalleryQuery = $em->createQuery('SELECT g.id FROM DJBlogBundle:SubGallery s JOIN s.childrenGallery g WHERE s.parentGallery=:parent')
                            ->setParameter('parent',$mainGalleryId);

        return $subGalleryQuery->getArrayResult();
    }

    public function getAllMainGalleries()
    {
        $em = $this->getEntityManager();
        $galleriesQuery = $em->createQuery('SELECT g FROM ApplicationSonataMediaBundle:Gallery g WHERE g.parent IS NULL AND g.enabled=1');

        return $galleriesQuery->getArrayResult();
    }
}