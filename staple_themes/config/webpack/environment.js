const { environment } = require('@rails/webpacker')

const webpack = require('webpack')

// // Add an ProvidePlugin
// environment.plugins.set('Provide',  new webpack.ProvidePlugin({
//     $: 'jquery',
//     jQuery: 'jquery',
//     jquery: 'jquery',
//     'window.Tether': "tether",
//     Popper: ['popper.js', 'default'],
//     ActionCable: 'actioncable',
//     Vue: 'vue',
//     VueResource: 'vue-resource',
//   })
// )

const config = environment.toWebpackConfig()
// export the updated config
module.exports = environment