const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .addEntry('page-mail-templates-manage', './assets/vue/pages/mail/template/manage.vue')
    .addEntry('sidebar', './assets/vue/page-elements/sidebar.vue')
    .addEntry("bootstrap", './assets/bootstrap.js')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader()
    .enableVueLoader(function(vueLoaderConfig){

        /**
         * @description this is required in order to use:
         * @link https://chrome.google.com/webstore/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd?hl=en
         */
        vueLoaderConfig.devtool = 'cheap-module-eval-sourcemap';
        vueLoaderConfig.version = 3;
    })
    .enableTypeScriptLoader(function (typeScriptConfigOptions) {
        typeScriptConfigOptions.transpileOnly = true;
        typeScriptConfigOptions.configFile    = 'tsconfig.json';
    }).configureSplitChunks(function(splitChunks) {
    /**
     * @description this configuration splits the common logic used in scripts and create `vendors.js` which contains it all
     *              this is required due to fact that scripts are being dynamically loaded thus the vendor must be always
     *              there once. It's impossible to just call entryName as if there are few entry names - without this
     *              the common vendor logic in each chunk will interfere and will break the scripts logic
     */
    splitChunks.cacheGroups = {
           commons: {
               test: /[\\/]node_modules[\\/]/,
                   name: 'vendors',
                   chunks(chunk){
                       /**
                        * @description exclude putting logic from this chunks into the vendor chunk
                        *              - bootstrap, due to the issues where some libs in output bundle break the bootstrap
                        */
                       return chunk.name !== 'bootstrap';
                   }
           }
       }
    });

let config = Encore.getWebpackConfig();

module.exports = config;