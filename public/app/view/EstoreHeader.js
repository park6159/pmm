Ext.define('Estore.view.EstoreHeader', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.estoreheader',

    initComponent: function() {
    	
    	if (this.appInfo) {
    		var userInfo = 'Welcome ' + this.appInfo.name;
    	} else {
    		var userInfo = '';
    	}

    	this.html = '<div style="background-color:#f0ab00;">' + 
	        '<img src="/images/title.png" align="absmiddle">' + 
	        '<span style="position:absolute; right:0; margin: 40px 0 0 0; width:300px; font-weight:bold; color:#fff;">' + userInfo + '</span></div>';
	        
        this.callParent(arguments);
    }

});