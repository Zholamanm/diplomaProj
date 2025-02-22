const { defineConfig } = require('@vue/cli-service');

module.exports = defineConfig({
    transpileDependencies: [
        'v3-infinite-loading'
    ],
    configureWebpack: {
        resolve: {
            alias: {
                'vue': '@vue/runtime-dom'
            }
        }
    }
});
