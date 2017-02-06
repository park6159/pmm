Ext.define('Estore.view.SurveyLinkList', {
	extend : 'Ext.grid.Panel',
	alias : 'widget.surveylinklist',
	border : true,
    
	initComponent : function() {
        
		this.store = new Estore.store.SurveyLinks();		
		
		this.columns = [{
                header: 'Link ID',
                dataIndex: 'link_id',
                hidden: true,
                sortable: false
			},{
                header: 'Campaign Name',
                dataIndex: 'campaign_name',
                sortable: true,
                width:200
            },{
                header: 'Created by',
                dataIndex: 'created_by',
                sortable: true,
                width:160
            },{
                header: 'Date Created',
                dataIndex: 'date_created',
                sortable: true,
                width:160
            },{
                header: 'Survey URL',
                dataIndex: 'survey_url',
                editor: {
					type:'textfield',
					tooltip : 'Click and copy the URL',				
			        listeners: {
			        	blur: function(field, value) {
				                field.setValue(value);
			            }
			        }
				},
                sortable: false, 
                flex:1
            },{
            	header: 'Action',
            	menuDisabled: true,
            	sortable: false,
            	xtype: 'actioncolumn',
            	width:100,
                items:[{
                	iconCls: 'icon-cancel',
                    tooltip: 'Remove this link',
                	handler: function(grid, rowIndex, colIndex)
                    {
                		this.up('grid').fireEvent('itemdeletebuttonclick',grid,rowIndex,colIndex);
            	    	
                    }
                }]  
            }];

		this.dockedItems = [{
            xtype: 'toolbar',
            items: [{
                text: 'Create New Link',
                action: 'addlink',
                iconCls: 'icon-plus',
                cls: 'x-toolbar-standardbutton',
                border: 1,
                style: {
                    borderColor: '#D1D1D1',
                    borderStyle: 'solid'
                }
            }, {
                xtype: 'tbspacer'
            }, '->', {
                itemId: 'refreshLinkData',
                action: 'refreshlinkdata',
                text: 'Refresh Data',
                iconCls: 'icon-refresh',
                cls:'x-btn-default-small',
                border: 1,
                style: {
                    borderColor: '#D1D1D1',
                    borderStyle: 'solid'
                }
            }]
		}];

		this.plugins = [{
			ptype: 'cellediting',
			clicksToEdit: 1,
			autoCancel: false,
			errorSummary: false
		}, 'gridfilters'];
		
		this.callParent(arguments);

	}

});