Ext.define('Estore.view.HomePanel', {
	extend : 'Ext.panel.Panel',
	alias : 'widget.homepanel',
    layout: {
        type: 'table',
        columns: 3,
        tableAttrs: {
            style: {
                width: '100%',
                height: '100%'
            }
        }
    },

    scrollable: true,

    defaults: {
        bodyPadding: '10 8',
        border: false
    }
});