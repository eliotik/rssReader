Ext.define("RssReader.view.topics.Grid", {
    extend: "Ext.grid.Panel",
    alias: "widget.topicsgrid",

    viewConfig: {
        loadMask: true
    },

    selType: 'cellmodel',
    store: 'Topics',

    forceFit: true,

    region: 'center',
    minWidth: 500,
    title: 'Feed topics',
    bodyStyle: {
        borderColor: ELM.Config.param('borderColor')
    },

    dockedItems: [{
        xtype: 'toolbar',
        style: {
            borderColor: ELM.Config.param('borderColor')
        },
        items: [{
            tooltip: 'Refresh list',
            iconCls:'refresh',
            id: 'refreshtopics'
        }]
    }],

    columns: [
        {
            text: 'Summary',
            dataIndex: 'summary',
            flex: 1,
            renderer: function(value, metaData, record) {
                return this.summaryRender(value, metaData, record)
            }
        },
        { text: 'Added', dataIndex: 'added', width: 150 }
    ],

    initComponent: function () {
        this.callParent();
    },

    listeners: {
        boxready: function(grid) {
            grid.headerCt.el.setStyle('borderColor', ELM.Config.param('borderColor'));
        }
    },

    summaryRender: function(value, metaData, record) {
        var summary = '<span>'+record.get('created')+'</span> ';
        summary += '<a href="'+record.get('link')+'" target="_blank">'+record.get('link')+'</a><br />';
        summary += '<b>'+record.get('title')+'</b><br />';
        summary += '<p>'+record.get('summary')+'</p>';
        summary += '<a href="'+record.get('link')+'" target="_blank">Read full story</a>';
        return summary;
    }

});