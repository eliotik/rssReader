Ext.define('RssReader.model.Feed', {
    extend: 'Ext.data.Model',
    fields: [
        { name: 'id', type: 'int' },
        { name: 'text', type: 'string' },
        { name: 'leaf', type: 'boolean' },
        { name: 'loaded', type: 'boolean', defaultValue: false },

        { name: 'name', type: 'string' },
        { name: 'url', type: 'string' }
    ],
    validations: [
        { type: 'presence', field: 'name' },
        { type: 'length', field: 'name', min: 3, max: 75, message: 'Wrong length (min: 3, max: 100)' },
        { type: 'presence', field: 'url' },
        { type: 'length', field: 'url', min: 10, max: 255, message: 'Wrong length (min: 10, max: 300)' }
    ],
    proxy: {
        type: 'ajax',
        actionMethods: {
            read: ELM.Config.Ajax("feedsList", "type"),
            create: ELM.Config.Ajax("feedCreate", "type")
        },
        reader: {
            type: 'json',
            root: 'feeds',
            successProperty: 'success'
        },
        writer: {
            type: 'json',
            writeAllFields: false
        },
        api: {
            create: ELM.Config.Ajax("feedCreate", "url"),
            read: ELM.Config.Ajax("feedsList", "url"),
            update: ELM.Config.Ajax("feedCreate", "url")
        }
    }
});