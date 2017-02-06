Ext.define('Estore.store.SurveyLinks', {
    extend : 'Ext.data.Store',
    model: 'Estore.model.SurveyLink',
    proxy: {
        type: 'ajax',
        url: '/report/surveylinkdata',
        reader: {
            type: 'json',
            rootProperty: 'results',
            idProperty: 'link_id'
        }
    },       
	autoDestroy: false,
    autoSync : false,
    autoLoad: false
 });