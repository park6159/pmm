Ext.define('Estore.controller.EstoreMenuController', {
    extend: 'Ext.app.Controller',
    views: ['EstoreMenu', 'Viewport'],

    refs: [{
            ref:'centerTabPanel',
            selector:'panel[itemId=centerPanel]'
        },{
            ref:'loginBtn',
            selector:'button[itemId=logBar]'          	
        }],

    init: function () {
        this.control(
        {
            'button[itemId=helpBar]': {
                click: function() {
                	this.addCenterTab('help_tab', 'Help', 'icon-info', 'helppanel');
                }
            },
            'button[itemId=logBar]': {
                click: this.processLog
            },
            
            'estoremenu': {
        		render: this.loadMenu,
            	click: function(menu, item, e) {
            		if(typeof item !== "undefined") {
                		if (item.xtype != 'toolbar') {
                			this.addCenterTab(item.tabId, item.text, item.iconCls, item.tabType);
                		}            			
            		}

            	}
            }
        });
    },

    loadMenu: function(menu, eOpts) {
    	var loginButton = this.getLoginBtn();
		Ext.Ajax.request({
			url : '/admin/getappdata',
			callback : function(options, success, response) {
				var o = {};
				o = Ext.decode(response.responseText);
				if (o.success) {
					loginButton.setText('Logout');
					loginButton.setIconCls('icon-checkout');	
					
				} else {
					loginButton.setText('Login');					
					loginButton.setIconCls('icon-checkin');
				}
			}
		});     	
    },
    
    processLog: function(button, e, eOpts) {
    	
    	var processType = button.getText(); 
    	
    	if (processType == 'Logout') {
            Ext.Ajax.request({
                scope: this,
                url: '/login/logoutprocess',
                callback:function(options, success, response) {
                    var o = {};
                    document.location.href = '/';
                }
            });    		
    	} else {
    		
        	var tabs = this.getCenterTabPanel();

            if(tabs.getChildByElement('login_tab') != null){
                tabs.setActiveTab('login_tab');
            }else{
                tabs.add({
                    id: 'login_tab',
                    title: 'Login',
                    layout: {
                        type: 'hbox',
                        padding:'5',
                        pack:'center',
                        align:'top'
                    }, 
                    iconCls: 'icon-lock-open',
                    closable:true,
        	        items: [{
        	        	margin: '100 0 0 0',
        	            border: false,
        	            xtype: 'loginform'
        	        }]                    
                }).show();

                tabs.setActiveTab('login_tab');
            }
    	}

    },

    addCenterTab: function(tabId, text, iconCls, tabType) {

    	var tabs = this.getCenterTabPanel();

        if(tabs.getChildByElement(tabId) != null){
            tabs.setActiveTab(tabId);
        }else{
            tabs.add({
                id: tabId,
                title: text,
                layout: 'fit',
                iconCls: iconCls,
                xtype: tabType,
                closable:true
            }).show();

            tabs.setActiveTab(tabId);
        }
    }
    
    
      
});


