/**
 * The main application class. An instance of this class is created by app.js when it calls
 * Ext.application(). This is the ideal place to handle application launch and initialization
 * details.
 */
Ext.define('Estore.Application', {
    extend: 'Ext.app.Application',
    name: 'Estore',
    requires: [
               'Ext.chart.axis.Numeric',
               'Estore.view.*',
               'Estore.store.*'


           ],
    views: [
            'HomePanel',
            'HelpPanel',
            'LoginForm',
            'EstoreHeader',
            'EstoreMenu',
            'SurveyResultList',
            'SurveyLinkList'
    ],

    controllers: [
                  'HomePanelController',
                  'HelpPanelController',
                  'LoginFormController',
                  'EstoreMenuController',
                  'SurveyResultListController',
                  'SurveyLinkListController'
                  ],
    
    stores: [ 
    ],
    
    launch: function () {
    	
    	_estoreApp = this;
    	
    	var viewportPanel = Ext.ComponentQuery.query('viewport')[0];
		Ext.Ajax.request({
			url : '/admin/getappdata',
			callback : function(options, success, response) {
				var o = {};
				o = Ext.decode(response.responseText);
				if (o.success) {
					_estoreApp.appData = o.appData;
					viewportPanel.removeAll();
					viewportPanel.createHeader(o.appData);
					viewportPanel.createMenu(o.appData);	
					viewportPanel.createCenter();
					
				} else {
					viewportPanel.removeAll();
					viewportPanel.createHeader(o.appData);
					viewportPanel.createMenu(o.appData);						
					viewportPanel.createCenter();

				}
				
				  setTimeout(function(){
					    Ext.get('loading').remove();
					    Ext.get('loading-mask').fadeOut({remove:true});
					  }, 250);
			}
		});    	
    }

});
