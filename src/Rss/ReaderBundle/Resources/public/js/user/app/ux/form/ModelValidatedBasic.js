/**
 * @class Ext.ux.form.ModelValidatedBasic
 * @version 1.0
 * @extends Ext.form.Basic
 *
 * Pretty much the same like {@link Ext.form.Basic} but with the functionality to validate 
 * the form with the model given validation. 
 *
 * {@link Ext.ux.form.ModelValidatedPanel} constructor, which passes them along to the BasicForm automatically.
 *
 * @author Jan-Victor Krille <jan-victor.krille@cn-consult.eu>
 */
Ext.define('Ext.ux.form.ModelValidatedBasic', {
	extend: 'Ext.form.Basic',
	
	config: {
		modelRecord: null
	},

	applyModelRecord: function(_modelRecord) {
		this.loadRecord(_modelRecord);
	},

	initialize: function(){
		this.callParent();

		this.getFields().each(function (_field) {
			_field.on("change", this.validateFieldByModel, this, { buffer: 250 });
		}, this);
	},

	/**
	 * Returns true if the form/record contains any invalid values. No fields will be marked as invalid
	 * as a result of calling this; to trigger marking of fields use {@link #isValid} instead.
	 */
	hasInvalidField: function() {
		var me = this;
		me.modelRecord.set(me.getFieldValues());

		var validateResult = me.modelRecord.validate();
		if(validateResult.items.length<1) return false;
		else return true;
	},

	/**
	 * Returns true if client-side validation of the model on the record is successful. Any invalid fields in the form will be
	 * marked as invalid. If you only want to determine overall form/record validity without marking anything,
	 * use {@link #hasInvalidField} instead.
	 * @return Boolean
	 */
	isValid: function() {
		var me = this;
		
		me.modelRecord.set(me.getFieldValues());
		me.clearInvalid();
		
		var validateResult = me.modelRecord.validate();
//		console.log("result", validateResult);
		me.markInvalid(validateResult);
		if(validateResult.items.length<1) return true;
		else return false;
	},

	/**
	 * This method validates a given field by the model declared in the form and mark the field as valid or invalid.
	 * @param {Object} _field The field to validate.
	 * @private
	 */
	validateFieldByModel: function(_field) {
		var me = this,
			fieldIsValid = true;
		
		me.modelRecord.set(_field.getName(), _field.getValue());
		
		var validateResult = me.modelRecord.validate();

		validateResult.each(function(_item, _index) {
			validateResult.clear();
			if (_item.field == _field.getName()) 
			{
				validateResult.add(_item);
				fieldIsValid = false;
				return false;
			}
		});
		
		if (fieldIsValid !== _field.wasValid) {
			_field.wasValid = fieldIsValid;
			_field.fireEvent('validitychange', _field, fieldIsValid);
		}
		
		_field.clearInvalid();
		me.markInvalid(validateResult);
	}
});