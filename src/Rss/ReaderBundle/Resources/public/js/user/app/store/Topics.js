Ext.define('RssReader.store.Topics', {
    extend: 'Ext.data.Store',

    requires: ['RssReader.model.Topic'],
    model: 'RssReader.model.Topic',

    storeId: 'Topics',
    autoLoad: false
});