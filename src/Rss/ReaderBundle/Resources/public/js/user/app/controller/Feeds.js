Ext.define('RssReader.controller.Feeds', {
    extend : 'Ext.app.Controller',

    requires: ['Ext.window.MessageBox'],

    stores : ['Feeds'],
    models : ['Feed'],
    views : [
        'feeds.Tree',
        'feeds.Create',
        'feeds.Edit'
    ],

    refs: [{
        ref: 'FeedsTree',
        selector: 'feedstree'
    },{
        ref: 'FeedCreateForm',
        selector: 'feedcreate'
    },{
        ref: 'FeedEditForm',
        selector: 'feededit'
    }],

    init : function() {
        this.control({
            'feedstree button#refreshFeeds' : {
                click : this.refreshAll
            },
            'feedstree button#addFeed' : {
                click : this.addFeed
            },
            'feedstree button#removeFeed' : {
                click : this.removeFeed
            },
            'feedstree button#editFeed' : {
                click : this.editFeed
            },
            'feedcreate button[action=submit]': {
                click: this.createFeed
            },
            'feededit button[action=submit]': {
                click: this.updateFeed
            },
            'feedstree' : {
                select : this.treeItemSelect,
                itemclick : this.treeItemClick
            }
        });
    },

    expandAll : function() {
        var tree = this.getFeedsTree();
        tree.expandAll();
    },

    collapseAll : function() {
        var tree = this.getFeedsTree();
        tree.collapseAll();
    },

    addFeed : function() {
        Ext.widget('feedcreate');
    },

    createFeed: function(button) {
        var win    = button.up('window'),
            form   = win.down('form'),
            formObj = form.getForm(),
            feed = Ext.create('RssReader.model.Feed', form.getValues()),
            errors = feed.validate();

        if (errors.items && errors.items.length || !form.isValid()) {
            formObj.markInvalid(errors);
        } else {
            formObj.submit({
                url: ELM.Config.Ajax("feedCreate", "url"),
                submitEmptyText: true,
                waitMsg: 'Creating feed...',
                scope: this,
                success: function(form, action) {
                    this.refreshAll((action.result.id) ? action.result.id : false);
                    win.close();
                },
                failure: function(form, action) {
                    if (action.failureType === Ext.form.action.Action.CONNECT_FAILURE) {
                        Ext.Msg.alert('Error',
                            'Status:'+action.response.status+': '+
                                action.response.statusText);
                    } else if (action.failureType === Ext.form.action.Action.SERVER_INVALID){
                        // server responded with success = false
                        Ext.Msg.alert('Invalid', action.result.message);
                    } else if (action.failureType === Ext.form.action.Action.CLIENT_INVALID){
                        Ext.Msg.alert('Invalid', "Check form errors before submit!");
                    }
                }
            });
        }
    },

    updateFeed: function(button) {
        var win    = button.up('window'),
            form   = win.down('form'),
            formObj = form.getForm(),
            feed = Ext.create('RssReader.model.Feed', form.getValues()),
            errors = feed.validate();
        if (errors.items && errors.items.length || !form.isValid()) {
            formObj.markInvalid(errors);
        } else {
            formObj.submit({
                url: ELM.Config.Ajax("feedUpdate", "url")+"/"+win.getSelectedNode().data.id,
                submitEmptyText: true,
                waitMsg: 'Updating feed...',
                scope: this,
                success: function(form, action) {
                    this.refreshAll((action.result.id) ? action.result.id : false);
                    win.close();
                },
                failure: function(form, action) {
                    if (action.failureType === Ext.form.action.Action.CONNECT_FAILURE) {
                        Ext.Msg.alert('Error',
                            'Status:'+action.response.status+': '+
                                action.response.statusText);
                    } else if (action.failureType === Ext.form.action.Action.SERVER_INVALID){
                        // server responded with success = false
                        Ext.Msg.alert('Invalid', action.result.message);
                    } else if (action.failureType === Ext.form.action.Action.CLIENT_INVALID){
                        Ext.Msg.alert('Invalid', "Check form errors before submit!");
                    }
                }
            });
        }
    },

    refreshAll : function(feedId) {
        var tree = this.getFeedsTree(),
            store = tree.getStore();
        if (!store.isLoading()) {
            tree.getStore().load({
                callback: function(records, operation) {
                    if (operation.wasSuccessful && Ext.isDefined(feedId) && feedId !== false) {
                        var node = store.getNodeById(feedId);
                        if (node) {
                            var sm = tree.getSelectionModel();
                            if (sm) {
                                sm.select(node);
                            }
                        }
                    }
                    tree.expandAll();
                }
            });
        }
    },

    editFeed : function() {
        var tree = this.getFeedsTree();
        if (tree.getSelectionModel().hasSelection()) {
            Ext.widget('feededit');
            var selectedNode = tree.getSelectionModel().getSelection(),
                win = this.getFeedEditForm(),
                form = win.down('form');
            win.setSelectedNode(selectedNode[0]);
            form.loadRecord(Ext.create('RssReader.model.Feed', selectedNode[0].data));
        }
    },

    removeFeed : function() {
        var tree = this.getFeedsTree();
        if (tree.getSelectionModel().hasSelection()) {
            var selectedNode = tree.getSelectionModel().getSelection();
            //tree.setLoading(true, true);
            Ext.Ajax.request({
                url: ELM.Config.Ajax("feedRemove", "url")+"/"+selectedNode[0].data.id,
                method: 'POST',
                scope: this,
                success: function(form, action) {
                    //tree.setLoading(false);
                    //selectedNode[0].remove(false);
                    this.refreshAll();
                },
                failure: function(form, action) {
                    tree.setLoading(false);
                    if (action.failureType === Ext.form.action.Action.CONNECT_FAILURE) {
                        Ext.Msg.alert('Error',
                            'Status:'+action.response.status+': '+
                                action.response.statusText);
                    } else if (action.failureType === Ext.form.action.Action.SERVER_INVALID) {
                        Ext.Msg.alert('Error', action.result.message);
                    } else {
                        Ext.Msg.alert('Error', "System error!");
                    }
                }
            });
        }
    },

    treeItemClick : function(view, record) {
        if (!record.isLeaf()) {
            if (record.isExpanded()) {
                record.collapse(false)
            } else {
                record.expand(false)
            }
        }
    },

    treeItemSelect: function(model, record) {
        var store = this.application.getTopicsController().getTopicsStore();
        store.getProxy().api.read = ELM.Config.Ajax("topicsList", "url")+"/"+record.get('id');
        store.load();
    }

});