Ext.define('Estore.store.SurveyResults', {
    extend : 'Ext.data.Store',
    model: 'Estore.model.SurveyResult',
    pageSize : 50,
	proxy: {
	    type: 'ajax',
	    url: '/report/surveyresultdata',
	    reader: {
	        type: 'json',
	        rootProperty: 'results',
	        idProperty: 'responseid',
	        totalProperty: 'totalCount'
	    }
	},    
    sorters: [{
        property: 'product_type',
        direction: 'ASC'
    }],	
    remoteFilter:true,
    remoteSort:true,    
	autoDestroy: false,
	autoSync : false,
	autoLoad: false

 });