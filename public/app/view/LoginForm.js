Ext.define('Estore.view.LoginForm', {
    extend: 'Ext.FormPanel',
    alias: 'widget.loginform',
    bodyStyle:'padding:10px',
    title:'Dashboard Login',
    iconCls: 'icon-lock-open',    
    buttonAlign:'center',
    autoScroll: true,
    frame: true,
    border: false,
    width: 300,
    initComponent: function() {
        this.items = [{
            xtype:'textfield',
            fieldLabel: 'Username',
            name: 'username',
            margin: '0 0 5 0',
            validator: function(v) {
                if (v === "") {
                    return "Email field is empty.";
                }
                return true;
            },
            anchor:'95%'
        },{
        	itemId: 'passwordfld',
            xtype:'textfield',
            fieldLabel: 'Password',
            inputType: 'password',
            name: 'password',
            validator: function(v) {
                if (v === "") {
                    return "Password field is empty.";
                }
                return true;
            },            
            anchor:'95%',
            enableKeyEvents:true
        	}
        
        ];

        this.buttons = [{
        	itemId: 'loginformsubmitbtn',
            iconCls: 'icon-save',
            text: '<b>Submit</b>'         
        },{
        	itemId: 'loginformcancelbtn',
            iconCls: 'icon-cancel',        
            text: '<b>Cancel</b>'      
        }];
        
        this.callParent(arguments);
    }

});
