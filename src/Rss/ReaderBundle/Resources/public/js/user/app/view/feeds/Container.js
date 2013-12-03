Ext.define('RssReader.view.feeds.Container' ,{
    extend: 'Ext.panel.Panel',
    alias: 'widget.feedscontainer',

    requires: [
        "RssReader.view.feeds.Tree",
        "RssReader.view.topics.Grid"
    ],

    border: true,
    layout: 'border',

    items: [
        {
            xtype: 'feedstree'
        },
        {
            xtype: 'topicsgrid'
        }
    ]


});