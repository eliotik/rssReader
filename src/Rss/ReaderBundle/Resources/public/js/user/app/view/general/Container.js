Ext.define('RssReader.view.general.Container' ,{
    extend: 'Ext.tab.Panel',
    alias: 'widget.generalcontainer',

    requires: [
        "RssReader.view.feeds.Container"
    ],

    region: 'center',
    padding: '5 10 10 10',
    style: {
        background: ELM.Config.param('borderColor')
    },
    bodyStyle: {
        borderColor: '#ADD2ED'
    },
    activeTab: 0,
    border: false,
    items: [{
        title: 'Feeds',
        layout: 'fit',
        bodyStyle: {
            background: ELM.Config.param('backgroundColor'),
            borderColor: ELM.Config.param('backgroundColor')
        },
        items: {
            xtype: 'feedscontainer',
            border: false,
            padding: '0 5 5 5',
            bodyStyle: {
                background: ELM.Config.param('backgroundColor')
            }
        }
    }]
});