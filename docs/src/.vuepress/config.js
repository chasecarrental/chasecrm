const { description } = require('../../package')

module.exports = {
  /**
   * Ref：https://v1.vuepress.vuejs.org/config/#title
   */
  title: 'Vuepress Docs Boilerplate',
  /**
   * Ref：https://v1.vuepress.vuejs.org/config/#description
   */
  description: description,

  /**
   * Extra tags to be injected to the page HTML `<head>`
   *
   * ref：https://v1.vuepress.vuejs.org/config/#head
   */
  head: [
    ['meta', { name: 'apple-mobile-web-app-capable', content: 'yes' }],
    ['meta', { name: 'apple-mobile-web-app-status-bar-style', content: 'black' }],
    ['link', { rel: "apple-touch-icon", type: "image/png", sizes: "180x180", href: "/apple-touch-icon.png"}],
    ['link', { rel: "icon", type: "image/png", sizes: "16x16", href: "/favicon-16x16.png"}],
    ['link', { rel: "icon", type: "image/png", sizes: "32x32", href: "/favicon-32x32.png"}],
    ['link', { rel: "manifest", href: "/site.webmanifest"}],
    ['link', { rel: "mask-icon", href: "/safari-pinned-tab.svg", color: "#5bbad5"}],
    ['meta', { name: "msapplication-TileColor", content: "#b91d47"}],
    ['meta', { name: "theme-color", content: "#ffffff"}],
  ],

  /**
   * Theme configuration, here is the default theme configuration for VuePress.
   *
   * ref：https://v1.vuepress.vuejs.org/theme/default-theme-config.html
   */
  themeConfig: {
    logo: '/img/laravel-crm-logo.png',
    repo: 'venturedrake/laravel-crm',
    docsDir: 'docs/src',
    docsRepo: 'venturedrake/laravel-crm',
    docsBranch: 'master',
    editLinks: true,
    editLinkText: 'Help us improve this page!',
    smoothScroll: true,
    lastUpdated: false,
    nav: [
      {
        text: 'Roadmap',
        link: 'https://github.com/venturedrake/laravel-crm/blob/master/README.md#roadmap',
      },
      {
        text: 'Discord',
        link: 'https://discord.gg/rygVyyGSHj'
      }
    ],
    sidebar: [
      {
        title: 'Getting Started',   // required
        collapsable: false, // optional, defaults to true
        children: [
          ['/', 'Overview'],
          ['/quickstart', 'Quick Start'],
          ['/installation', 'Installation'],
          ['/configuration', 'Configuration'],
          ['/upgrading', 'Upgrade Guide'],
          ['/security', 'Security'],
          ['/contributing', 'Contributing'],
        ]
      },
      {
        title: 'User Interface',
        collapsable: false, // optional, defaults to true
        children: [
          '/user-interface/overview',
        ]
      },
      {
        title: 'Guide',
        collapsable: false, // optional, defaults to true
        children: [
          '/guide/addresses',
        ]
      },
    ]
  },

  /**
   * Apply plugins，ref：https://v1.vuepress.vuejs.org/zh/plugin/
   */
  plugins: [
    '@vuepress/plugin-back-to-top',
    '@vuepress/plugin-medium-zoom',
  ]
}