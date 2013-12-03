Ext.define('RssReader.view.feeds.Edit', {
    extend: 'Ext.window.Window',
    alias: 'widget.feededit',

    requires: ['RssReader.view.feeds.Form'],

    title: 'Edit Feed',
    layout: 'fit',
    autoShow: true,
    modal: true,
    resizable: false,
    closable: false,

    selectedNode: false,

    initComponent: function() {
        this.items = [{
            xtype: 'feedform'
        }];

        this.buttons = [
            {
                text: 'Update',
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
    },

    getSelectedNode: function() {
        return this.selectedNode;
    },

    setSelectedNode: function(node) {
        this.selectedNode = node;
    }
});