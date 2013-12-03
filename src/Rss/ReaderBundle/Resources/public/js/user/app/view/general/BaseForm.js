Ext.define('RssReader.view.general.BaseForm', {
    extend: 'Ext.ux.form.ModelValidatedPanel',
    requires: ['Ext.ux.form.ModelValidatedPanel'],

    fieldDefaults: {
        msgTarget: 'side'
    },
    defaultType: 'textfield',

    defaults: {
        anchor: '100%'
    },
    padding: '5',
    border: false
});