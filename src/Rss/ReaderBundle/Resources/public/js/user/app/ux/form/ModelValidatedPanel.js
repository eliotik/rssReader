/**
 * @class Ext.ux.form.ModelValidatedPanel
 * @version 1.0
 * @extends Ext.form.Panel
 *
 * A form-panel class pretty much like {@link Ext.form.Panel} but for validation via a given model.
 *
 * @xtype modelvalidatedform
 *
 * @author Jan-Victor Krille <jan-victor.krille@cn-consult.eu>
 */
Ext.define('Ext.ux.form.ModelValidatedPanel', {
	extend: 'Ext.form.Panel',

	alias: 'widget.modelvalidatedform',
	
	requires: ['Ext.ux.form.ModelValidatedBasic'],
	
	/**
	 * @cfg {String} model
	 * The model-type with which the form is validated.
	 */
	
	config: {
		modelRecord: null
	},
	
	applyModelRecord: function(_modelRecord) {
		this.getForm().setModelRecord(_modelRecord);
	},
	
	initComponent: function() {
		var me = this;

		me.modelRecord = Ext.ModelManager.create({}, me.model);

		me.callParent();
	},
	
	initItems: function() {
		var me = this;

		// we need to turn off all our fields validation methods, because we validate them by our own. 
		me.fieldDefaults.validateOnChange = false;
		me.fieldDefaults.validateOnBlur = false;
		for(i in me.initialConfig.items) {
			delete me.initialConfig.items[i].vtype;
		}
		
		me.callParent();
	},

	/**
	 * @private
	 */
	createForm: function() {
		var me = this;
		var basicForm = Ext.create('Ext.ux.form.ModelValidatedBasic', me, Ext.applyIf({ listeners: {}, modelRecord: me.modelRecord }, me.initialConfig));
		return basicForm;
	}
	
});