Ext.define('Estore.controller.SurveyResultListController', {
    extend: 'Ext.app.Controller',
    stores: ['SurveyResults'],
    models: ['SurveyResult'],
    views: ['SurveyResultList'],   
    refs: [{
    	ref:'surveyresultgrid' , selector:'surveyresultlist'
    }],
    init: function() {      
       
        this.control({
        	'button[action=downloaddata]': {
    			click: this.downloadResult
    		},        	  	
        	'button[action=refreshsurveydata]': {
    			click: this.loadSurveyResultStore
    		},  
            'surveyresultlist': {
            	render: this.loadSurveyResultStore
            }
        });
    },

    loadSurveyResultStore: function() {
        var surveyResultGrid = this.getSurveyresultgrid();
        surveyResultGrid.getStore().loadPage(1);
        
    },  
    
    downloadResult: function() {

        var surl = '/report/downloadinexcel';

        Ext.getBody().mask("Downloding spreadsheet data ..");

    	Ext.DomHelper.append(document.body, {
            tag: 'iframe',
            frameBorder: 0,
            width: 0,
            height: 0,
            css: 'display:none;visibility:hidden;height:1px;',
            src: surl
        });
    	
		setTimeout(function(){ 
			Ext.getBody().unmask();
		}, 5000); 
    }
});


