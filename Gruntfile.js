module.exports = function(grunt) {
    grunt.initConfig({
        baseURL: "src/Acme/**/Resources",
        shell: {
            clearCache: {
                options: {
                    stdout: true
                },
                command: 'app/console cache:clear'
            },
            asseticDump: {
                options: {
                    stdout: true
                },
                command: 'app/console assetic:dump <%= dir %>'
            },
            assetsInstall: {
                options: {
                    stdout: true
                },
                command: 'app/console assets:install <%= dir %>'
            }
        },
        watch: {
            options: {
                dateFormat: function(time) {
                    grunt.log.writeln('The watch finished in ' + time + 'ms at' + (new Date()).toString());
                    grunt.log.writeln('Waiting for more changes...');
            },
                livereload: true
            },
            branchChanged: { // clear cache if the branch is changed
                files: '.git/HEAD',
                tasks: ['shell:clearCache'],
                options: {
                    spawn: true
                }
            },
            scripts: {
                files: ['<%= baseURL %>/**/*.js',
                        '<%= baseURL %>/**/*.css',
                        '<%= baseURL %>/**/*.sass',
                        '<%= baseURL %>/**/*.less',
                        '<%= baseURL %>/**/*.twig',
                        'less/**/*.less'],
                tasks: ['shell:asseticDump', 'shell:assetsInstall', 'less:development'],
                options: {
                    interrupt: true
                }
            },
            less: {
                files: ['less/**/*.less'],
                tasks: ['less:development'],
                options: {
                    interrupt: true,
        }
            }
        },
        open: {
            dev: {
                path: 'http://127.0.0.1/vhosts/travel-site/web/app_dev.php',
                app: 'Chrome'
            }
        },
        less: {
            development: {
                options: {
                    paths: ['web/css']
                },
                files: {
                    "web/css/main.css": "less/main.less"
                }
                
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-shell');
    grunt.registerTask('default', ['shell:asseticDump', 'shell:assetsInstall']);
    grunt.loadNpmTasks('grunt-open');
    grunt.loadNpmTasks('grunt-contrib-less');

    grunt.registerTask('dump', 'A task to dump all assets.', function() {
        grunt.task.run("shell:asseticDump");
        grunt.task.run("shell:assetsInstall");
    });

    grunt.registerTask('all', 'A task to dump all assets and clear cache.', function() {
        grunt.task.run("shell:clearCache");
        grunt.task.run("shell:asseticDump");
        grunt.task.run("shell:assetsInstall");
    });

    grunt.registerTask('run', 'A task to dump all assets and clear cache.', function() {
        grunt.task.run("open");
        grunt.task.run("watch");       
    });
    
    grunt.registerTask('less', 'A task to dump all assets and clear cache.', function() {
        grunt.task.run("all");
        grunt.task.run("open");
        grunt.task.run("watch:less");       
    });
    
    grunt.registerTask('setDir', 'A task to set the web dir of the project.', function() {
        grunt.config.set("dir", "web");
        grunt.log.writeln("DIR: " + grunt.config.get("dir"));
        grunt.log.writeln("BASE_URL: " + grunt.config.get("baseURL"));
    });

    console.info("BASE_URL: " + grunt.config.get("watch").scripts.files[0]);
    grunt.task.run(['setDir']);
};