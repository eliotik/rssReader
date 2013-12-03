Ext.Loader.setPath('Ext.ux', '/bundles/rssreader/js/user/app/ux');
Ext.application({
    requires: ['Ext.container.Viewport'],
    name: 'RssReader',

    appFolder: '/bundles/rssreader/js/user/app',

    controllers: ['Feeds', 'Topics'],

    views: ['general.Header', 'general.Container'],

    launch: function() {
        //noinspection JSValidateTypes
        Ext.create('Ext.container.Viewport', {
            layout: 'border',
            minWidth: 640,
            minHeight: 480,
            items: [{
                xtype: 'generalheader'
            }, {
                xtype: 'generalcontainer'
            }]
        });

        Ext.tip.QuickTipManager.init();

        Ext.get("loading").remove()
    }
});