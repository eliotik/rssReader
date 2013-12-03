Ext.define('RssReader.view.general.Header' ,{
    extend: 'Ext.panel.Panel',
    alias: 'widget.generalheader',

    requires: [
        "RssReader.view.general.AppHeader",
        "RssReader.view.general.AuthHeaderForm"
    ],

    region: "north",
    id: "north-region",
    border: false,
    bodyStyle: {
        background: ELM.Config.param('borderColor'),
        padding: '10px'
    },
    layout: {
        type: "vbox",
        align: "stretch"
    },
    items: [
        {
            xtype: "container",
            layout: "hbox",
            items: [
                {
                    xtype: "generalappheader"
                },
                {
                    xtype: "container",
                    flex: 1
                },
                {
                    xtype: "generalauthheader"
                }
        ]}
    ]


});