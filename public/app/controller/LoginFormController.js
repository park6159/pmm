Ext.define('Estore.controller.LoginFormController', {
    extend: 'Ext.app.Controller',
    views: ['LoginForm'],
    refs: [{
    	ref:'loginFormPanel', selector:'loginform'       	
    }],
    
    init: function() {
    	this.control({
    		'[itemId=passwordfld]': {
        		specialkey: function(field, e){
                    if (e.getKey() == e.ENTER) {
                    	this.submitLogin();
                    }
        		}
    		},

            'button[itemId=loginformsubmitbtn]': {
                click: this.submitLogin
            },

            'button[itemId=loginformcancelbtn]': {
                click: this.cancelLogin
            }
    	}); 	
        
    },
    
    submitLogin: function() {
		var loginForm = this.getLoginFormPanel();
		
        if (loginForm.getForm().isValid()) {
        	loginForm.getForm().submit({
                url: '/login/loginprocess',
                method: 'POST',
                success: function(form, action) {
          	    	document.location.href = '/admin';   
                },
                failure: function(form, action) {
                    Ext.Msg.alert('Failed', action.result.error);
                }
            });
        }
           	
    },
    
    cancelLogin: function() {
    	this.initForm();
    }  
});
