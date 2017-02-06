Ext.define('Estore.controller.SurveyLinkListController', {
    extend: 'Ext.app.Controller',
    stores: ['SurveyLinks'],
    models: ['SurveyLink'],
    views: ['SurveyLinkList'],   
    refs: [{
    	ref:'surveylinkgrid' , selector:'surveylinklist'
    }],
    init: function() {      
       
        this.control({
        	
        	'button[action=addlink]': {
    			click: this.popAddLinkWin
    		},
			'button[action=refreshlinkdata]': {
				click: this.loadSurveyLinkStore
			},
            'surveylinklist': {
                render: this.loadSurveyLinkStore
            }
        });
    },

    loadSurveyLinkStore: function() {
        var surveyLinkGrid = this.getSurveylinkgrid();
        surveyLinkGrid.getStore().load();
    },


	popAddLinkWin: function() {
		
		var surveyLinkGrid = this.getSurveylinkgrid();
		
		Ext.Msg.prompt("Create New Link", "Enter a Campaign code to create new link:", function(btnText, sInput){
            if(btnText === 'ok'){

            	Ext.getBody().mask("Submitting Data ..");

                Ext.Ajax.request({
                    url: '/report/addnewlink',
                    params: {campaign_name:sInput},
                    callback:function(options, success, response) {
                     	var m = {};
                        m = Ext.decode(response.responseText);
                        if(!(m.success)) {
                        	Ext.getBody().unmask();
                        	Ext.MessageBox.alert('Warning', m.msg);
                        } else {   
                        	Ext.getBody().unmask();
                        	surveyLinkGrid.getStore().load();
    					}                                                        
                    }
                });
            }
        }, this);
    },
    
    deleteRow : function(click, rowIndex) {    	
    	
    	var grid = click.up('grid');
    	var rec = grid.getStore().getAt(rowIndex);
    	var to_be_removed_name = rec.get('name');
    	var to_be_removed_userid = rec.get('userid');
    	var role = rec.get('role');
		
    	Ext.Msg.show({
		    title: 'Confirm Delete',
		    msg: 'Are you sure you want to delete '+to_be_removed_name+' as '+role+' ?',
		    width: 550,
		    buttons: Ext.Msg.YESNO,
		    fn: showResult,
		    icon: Ext.MessageBox.WARNING
		});	
    	
    	function showResult(btn){
    		if(btn == 'yes'){ 
    			Ext.Ajax.request({
    		    	scope: this,
    	            url: '/admin/removeuserdata',
    	            params: {
    	            			userid: to_be_removed_userid
    	            		},
    	            		callback : function(options, success, response) {
    	    	                //var response = Ext.decode(response.responseText);
    	    	                if(response.responseText.indexOf('true') <= -1){
    	    	                    Ext.Msg.alert("Error", "Failed to delete. "+ response.responseText);
    	    	                } else {
    	    	                    Ext.Msg.alert("Success","Removed Successfully");	                    
    	    	                    _estoreApp.getController('AdminUserListController').loadAdminUserStore();                
    	    	                }
    	    	            }       	   			
    	    	});
    		}
    	}		
    }
});


