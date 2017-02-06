Ext.define('Estore.controller.HelpPanelController', {
    extend: 'Ext.app.Controller',
	stores: [],
	models: [],
    views: ['HelpPanel'],
    refs: [{
    	ref:'helppage' , selector:'helppanel'
	}],
    init: function() {      
       
        this.control({
            'helppanel': {
                afterrender: this.loadHelpData
            }
        });
    },

    loadHelpData: function(p, opt) {
					
		p.removeAll();
		
    	p.add({
    		
	    	layout: 'fit',
	    	
	    	items:[{
	    		html: '<font style="font-size:15px;"><strong>&nbsp;&nbsp;&nbsp;Popular Topics</strong></font>'
	                   		
	    	}],
	    	colspan: 3		    		
    	});
    	
    	p.add({
    		html: '<div style="height: 70px; padding-top: 8px; text-align:center; color:#FFF; font-weight: bold; background-color:#00BCD6; background-image:url("/images/dash_header1.gif"); background-repeat: no-repeat; background-position:left;"><h2>How can I request Inventory trasfer?</h2></div>'
    	},{
    		html: '<div style="height: 70px; padding-top: 8px; text-align:center; color:#FFF; font-weight: bold; background-color:#89C541; background-image:url("/images/dash_header2.gif"); background-repeat: no-repeat; background-position:left;"><h2>How Can I change Inventory watermark for eStore?</h2></div>'
    	},{
    		html: '<div style="height: 70px; padding-top: 8px; text-align:center; color:#FFF; font-weight: bold; background-color:#FFA600; background-image:url("/images/dash_header3.gif"); background-repeat: no-repeat; background-position:left;"><h2>How can I check the status of inventory status?</h2></div>'
    	});
    	/*
    	p.add({
    		html: '<font style="font-size:15px;"><strong>&nbsp;&nbsp;&nbsp;Notifications</strong></font><div id="list3">' +
			   '<ul>' +
			   '<li>' + o.notifications[0] + '</li>' +
			   '<li>' + o.notifications[1] + '</li>' +
			   '<li>' + o.notifications[2] + '</li>' +
			   '<li>' + o.notifications[3] + '</li>' +
			   '<li>' + o.notifications[4] + '</li>' +		    			   
			   '</ul>' +
			   '</div>'
    	},{			    		
    		html: '<font style="font-size:15px;"><strong>&nbsp;&nbsp;&nbsp;Top 5 Most Selling Products</strong></font><div id="list4">' +
    			   '<ol>' +
    			   '<li>' + o.most_selling[0] + '</li>' +
    			   '<li>' + o.most_selling[1] + '</li>' +
    			   '<li>' + o.most_selling[2] + '</li>' +
    			   '<li>' + o.most_selling[3] + '</li>' +
    			   '<li>' + o.most_selling[4] + '</li>' +
    			   '</ol>' +
    			   '</div>'
    	},{

    		html: '<font style="font-size:15px;"><strong>&nbsp;&nbsp;&nbsp;Recent Tasks</strong></font><div id="list3">' +
			   '<ul>' +
			   '<li>' + o.recent_tasks[0] + '</li>' +
			   '<li>' + o.recent_tasks[1] + '</li>' +
			   '<li>' + o.recent_tasks[2] + '</li>' +
			   '<li>' + o.recent_tasks[3] + '</li>' +
			   '<li>' + o.recent_tasks[4] + '</li>' +
			   '</ul>' +
			   '</div>'
    	});	
    	
    	p.add({
    		
	    	layout: 'fit',
	    	
	    	items:[{
	    		html: '<font style="font-size:15px;"><strong>&nbsp;&nbsp;&nbsp;Monthly Sales Trend</strong></font>',
	    	},{
	            xtype: 'salestrendchart'
	                   		
	    	}],
	    	colspan: 2 
    	},{
	    	layout: 'fit',
	    	items:[{
	    		html: '<font style="font-size:15px;"><strong>&nbsp;&nbsp;&nbsp;Sales By Component</strong></font>',
	    	},{				    		
	            xtype: 'salespiechart'
	                   		
	    	}]			    		
    	});
    	*/

	}

});


