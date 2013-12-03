Ext.define('RssReader.view.feeds.Form', {
    extend: 'RssReader.view.general.BaseForm',
    alias: 'widget.feedform',

    requires: ['RssReader.view.general.BaseForm'],
    model: 'RssReader.model.Feed',

    items: [{
        name : 'name',
        fieldLabel: 'Name',
        blankText: 'Name is required',
        allowBlank: false
    },
    {
        name : 'url',
        fieldLabel: 'Url',
        blankText: 'Url is required',
        allowBlank: false
    },
    {
        xtype: 'hidden',
        name: 'user',
        value: ELM.Config.param('user')
    }]
});