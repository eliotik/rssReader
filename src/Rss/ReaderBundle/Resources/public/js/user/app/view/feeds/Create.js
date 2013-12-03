Ext.define('RssReader.view.feeds.Create', {
    extend: 'Ext.window.Window',
    alias: 'widget.feedcreate',

    requires: ['RssReader.view.feeds.Form'],

    title: 'Create Feed',
    layout: 'fit',
    autoShow: true,
    modal: true,
    resizable: false,
    closable: false,

    initComponent: function() {
        this.items = [{
            xtype: 'feedform'
        }];

        this.buttons = [
            {
                text: 'Create',
                action: 'submit',
                formBind: true
            },
            {
                text: 'Cancel',
                scope: this,
                handler: this.close
            }
        ];

        this.callParent(arguments);
    }
});