Ext.define('RssReader.controller.Topics', {
    extend : 'Ext.app.Controller',

    requires: ['Ext.window.MessageBox'],

    stores : ['Topics'],
    models : ['Topic'],
    views : [
        'topics.Grid'
    ],

    refs: [{
        ref: 'TopicsGrid',
        selector: 'topicssgrid'
    }],

    init : function() {
        this.control({
            'topicsgrid button#refreshtopics' : {
                click : this.refreshTopics
            }
        });
    },

    refreshTopics : function() {
        var store = this.getTopicsStore();
        if (!store.isLoading()) {
            store.load();
        }
    }

});