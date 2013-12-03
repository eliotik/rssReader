Ext.define('RssReader.store.Feeds', {
    extend: 'Ext.data.TreeStore',

    requires: ['RssReader.model.Feed'],
    model: 'RssReader.model.Feed',

    storeId: 'Feeds',
    autoLoad: true,
    root: {
        text: 'Feeds',
        id: 'feedsTree'
    },

    folderSort: true,
    sorters: [{
        property: 'text',
        direction: 'ASC'
    }]
});