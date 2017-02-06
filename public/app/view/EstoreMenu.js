Ext.define('Estore.view.EstoreMenu', {
    extend: 'Ext.menu.Menu',
    alias: 'widget.estoremenu',
    margin: '0 0 0 0',
    padding: '0 10 50 10',
    floating: false,
    initComponent: function() {
        if (this.appInfo == null) {
    		this.items = [{
                tabId: 'home_tab',
                text: 'Home',
                iconCls: 'icon-house',
                tabType: 'homepanel'
            }];
    	} else {
            this.items = [{
                tabId: 'home_tab',
                text: 'Home',
                iconCls: 'icon-house',
                tabType: 'homepanel'
            }, {        	
                tabId: 'survey_data_tab',
                text: 'Survey Data',
                iconCls: 'dashboard',
                tabType: 'surveyresultlist'       
            }, {
                tabId: 'survey_link_tab',
                text: 'Survey Link',
                iconCls: 'icon-wh-store',
                tabType: 'surveylinklist'                   	
            }];        		
    	}
		



        this.dockedItems = [{
            xtype: 'toolbar',
            margin: '0 0 0 0',
            items: [{
            	itemId: 'helpBar',
                iconCls:'icon-info',
                text:'Help'            	
            },{
            	itemId: 'logBar',
                iconCls:'icon-checkout',
                text:'Logout'
            }]
        }],
        
        this.callParent(arguments);
    }
});