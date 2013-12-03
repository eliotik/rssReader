Ext.define("RssReader.view.feeds.Tree", {
    extend: "Ext.tree.Panel",
    alias: "widget.feedstree",

    store: 'Feeds',

    viewConfig: {
        preserveScrollOnRefresh: true,
        loadMask: true
    },

    forceFit: true,

    useArrows: true,
    rootVisible: false,
    region: 'west',
    width: 300,
    minWidth: 200,
    title: 'Feeds list',
    padding: '0 5 0 0',
    bodyStyle: {
        borderColor: ELM.Config.param('borderColor')
    },

    dockedItems: [{
        xtype: 'toolbar',
        style: {
            borderColor: ELM.Config.param('borderColor')
        },
        items: [{
            iconCls:'add',
            tooltip: 'Add feed',
            id: 'addFeed'
        }, {
            tooltip: 'Edit selected feed',
            iconCls:'edit',
            id: 'editFeed'
        }, {
            tooltip: 'Remove selected feed',
            iconCls:'delete',
            id: 'removeFeed'
        }, {
            tooltip: 'Refresh list',
            iconCls:'refresh',
            id: 'refreshFeeds'
        }]
    }],

    root:{
        expanded: true
    },

    initComponent: function () {
        this.callParent();
    },

    listeners: {
        boxready: function(tree) {
            tree.headerCt.el.setStyle('borderColor', ELM.Config.param('borderColor'));
        }
    }
});