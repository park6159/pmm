Ext.define('Estore.controller.HomePanelController', {
    extend: 'Ext.app.Controller',
	stores: [],
	models: [],
    views: ['HomePanel'],
    refs: [{
    	ref:'homepage' , selector:'homepanel'
	}],
    init: function() {      
       
        this.control({
            'homepanel': {
                afterrender: this.loadHomeData
            }
        });
    },

    loadHomeData: function(p, opt) {
		p.removeAll();
		p.add({
	    	layout: 'fit',
	    	items:[{
	    		height: 250,
	    		html: '<center><img src="/images/dashboard_icon.png"><p></center>'
	    	
	    	}],
	    	colspan: 3 
		});

    }
});


