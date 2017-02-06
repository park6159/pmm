Ext.define('Estore.view.Viewport', {
    extend: 'Ext.container.Viewport',
    layout: {
        type: 'border'
    },
    
    initComponent: function() {
        this.callParent(arguments);  
    },
    
	createHeader: function(appData) {
		
		// Create header component
		var header = Ext.widget('estoreheader',{
        	appInfo: appData
        });

		// Add a north region to this viewport and add the header component to it
	    this.add({
	        itemId: 'headerPanel',
	        region: 'north',
	        layout: 'fit',
	        height: 70,
	        items: [header]

	    });
	},
	
	createMenu: function(appData){
		
		var menu = Ext.widget('estoremenu',{
        	appInfo: appData
        });
		
	    this.add({
	        itemId: 'menuPanel',	    	
	        region: 'west',
	        title: 'Menu',
	        collapsible: true,
	        width: 180,
	        split: true,
	        layout: {
	            type: 'vbox',
	            align: 'stretch'
	        },
	        items: [{
	        	border: false,
	        	frame: false,
	        	itemId: 'mainMenu',
	            items: [menu]           	
	        }]
	        
	    });		
	},
	
	createCenter: function(){
		this.add({
	        itemId: 'centerPanel',
	        region: 'center',
	        xtype: 'tabpanel',
	        items: [{
                id: 'home_tab',
                title: 'Home',
                iconCls: 'icon-house',
                xtype: 'homepanel'
	        }]
	    });

	}
	    
});
