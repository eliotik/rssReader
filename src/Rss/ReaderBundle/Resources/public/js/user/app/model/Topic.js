Ext.define('RssReader.model.Topic', {
    extend: 'Ext.data.Model',
    fields: [
        { name: 'id', type: 'int' },
        { name: 'link', type: 'string' },
        { name: 'title', type: 'string' },
        { name: 'text', type: 'string' },
        { name: 'ts', type: 'string' },
        { name: 'summary', type: 'string' },
        { name: 'created', type: 'string' },
        { name: 'feedId', type: 'int' },
        { name: 'added', type: 'string' }
    ],
    validations: [
        { type: 'presence', field: 'text' },
        { type: 'length', field: 'text', min: 3, message: 'Wrong length (min: 3)' }
    ],
    proxy: {
        type: 'ajax',
        actionMethods: {
            read: ELM.Config.Ajax("topicsList", "type")
        },
        reader: {
            type: 'json',
            root: 'topics',
            successProperty: 'success'
        },
        writer: {
            type: 'json',
            writeAllFields: false
        },
        api: {
            read: ELM.Config.Ajax("topicsList", "url")
        }
    }
});