Ext.define('Estore.view.HelpPanel', {
	extend : 'Ext.panel.Panel',
	alias : 'widget.helppanel',
    layout: {
        type: 'table',
        columns: 3
        /*
        tableAttrs: {
            style: {
                width: '100%'
            }
        }
        */
    },

    scrollable: true,

    defaults: {
        bodyPadding: '10 8',
        border: false
    }
});