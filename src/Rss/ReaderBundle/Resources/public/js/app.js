Ext.application({
    requires: ['Ext.container.Viewport'],
    name: 'RssReader',

    appFolder: '/bundles/rssreader/js/user/app',

    controllers: [],

    views: [],

    launch: function() {
        //noinspection JSValidateTypes
        Ext.create('Ext.container.Viewport', {
            layout: 'border',
            minWidth: 640,
            minHeight: 480,
            items: []
        });

        Ext.tip.QuickTipManager.init();

        Ext.get("loading").remove()
    }
});