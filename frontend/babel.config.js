module.exports = {
  presets: [
    '@vue/cli-plugin-babel/preset'
  ],
  overrides: [
    {
      include: [
        /node_modules[\\/]v3-infinite-loading[\\/]/
      ],
      presets: ['@babel/preset-env']
    }
  ]
}
