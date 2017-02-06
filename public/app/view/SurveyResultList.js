Ext.define('Estore.view.SurveyResultList', {
	extend : 'Ext.grid.Panel',
	alias : 'widget.surveyresultlist',
	border : true,
    
	initComponent : function() {
        
		this.store = new Estore.store.SurveyResults();		  
        
		this.columns = [{
                header: 'ID',
                dataIndex: 'responseid',
                hidden: true,
                sortable: false
			},{				
                header: 'ID',
                dataIndex: 'ip_source',
                hidden: true,
                sortable: false
                
			},{
				header : 'Survey Information',
                columns: [{
                    header: 'Survey Date',
                    dataIndex: 'date_created',
                    hidden: false,
                    width: 120,
                    sortable: false
    			},{				
                    header: 'Business Model',
                    dataIndex: 'business_model',
                    hidden: false,
                    width: 120,
                    sortable: false
    			},{				
                    header: 'Company Size',
                    dataIndex: 'company_size', 
                    hidden: false,
                    width: 120,
                    sortable: false
    			},{				
                    header: 'Region',
                    dataIndex: 'region',
                    width: 120,
                    hidden: false,
                    sortable: false                  	
                }]
    
			},{				
				
                header: 'Q1: Number<br> Of Systems?',
                dataIndex: 'q1', 
                align: 'center',
                width: 120,
                sortable: true
			},{				
                header: 'Q2: Plan to move to <br>a single customer database',
                dataIndex: 'q2', 
                width:280,
                sortable: true
                
            },{            	
    			header : 'Q3: Plans to use technologies to understand data',
                columns: [{
	                    text: 'Dashboard',
	                    dataIndex: 'q3_dashboard',
	                    sortable: false,
	                    width:200
	                },{
	                	text: 'Web Analytics',
	                    dataIndex: 'q3_web',
	                    sortable: false,	                    
	                    width:200
	                },{
	                	text: 'Text Analytics',
	                    dataIndex: 'q3_text',
	                    sortable: false,	                    

	                    width:200  
	                },{
	                	text: 'Predictive Analytics',
	                    dataIndex: 'q3_predictive',
	                    sortable: false,	                    

	                    width:200
	                },{
	                	text: 'Location Analytics',
	                    dataIndex: 'q3_location',
	                    sortable: false,	                    

	                    width:200              	
                }]
            },{            	
    			header : 'Q4: Ability to respond to customer intent',
                columns: [{
	                    text: 'Email',
	                    dataIndex: 'q4_email',
	                    sortable: false,
	                    width:200
	                },{
	                	text: 'Online/Web',
	                    dataIndex: 'q4_online',
	                    sortable: false,	                    
	                    width:200
	                },{
	                	text: 'Mobile',
	                    dataIndex: 'q4_mobile',
	                    sortable: false,	                    
	                    width:200  
	                },{
	                	text: 'Call Center',
	                    dataIndex: 'q4_callcenter',
	                    sortable: false,	                    
	                    width:200
	                },{
	                	text: 'Store',
	                    dataIndex: 'q4_store',
	                    sortable: false,	                    
	                    width:200              	
                }]
        
            },{
    			header : 'Surveyee Information',
                columns: [{

	                    header: 'First Name',
	                    dataIndex: 'first_name',
	                    hidden: false,
	                    width:120, 
	                    sortable: false            	
	                },{
	                    header: 'Last Name',
	                    dataIndex: 'last_name',
	                    hidden: false,
	                    width:120, 
	                    sortable: false   
	                },{
	                    header: 'Email',
	                    dataIndex: 'email',
	                    hidden: false,
	                    width:140, 
	                    sortable: false 	                    
	                },{
	                    header: 'Company Name',
	                    dataIndex: 'company_name',
	                    hidden: false,
	                    width:180, 
	                    sortable: false            	
	                },{
	                    header: 'Job Title',
	                    dataIndex: 'job_title',
	                    hidden: false,
	                    width:180, 
	                    sortable: false            	
	                },{
	                    header: 'Phone',
	                    dataIndex: 'phone',
	                    hidden: false,
	                    width:120, 
	                    sortable: false           	
	                },{      
	                    header: 'State',
	                    dataIndex: 'state',
	                    hidden: false,
	                    sortable: false   
                }]
            },{   
    			header : 'Campaign Information',
                columns: [{
	                header: 'Campaign Code',
	                dataIndex: 'campaign_code',
	                hidden: false,
	                width:160, 
	                sortable: false  
                }, {

	                header: 'Campaign URL',
	                dataIndex: 'campaign_url',
	                hidden: true,
	                width:320, 
	                sortable: false                 	
                }]
            }];

		this.dockedItems = [{
            xtype: 'toolbar',
            reference: 'dockedToolbar',
            items: [{
                    text: 'Download Data',
    				action: 'downloaddata',
                    iconCls: 'excel32icon',
                    cls: 'x-btn-default-small',
                    border: 1,
        			style: {
        			    borderColor: '#D1D1D1',
        			    borderStyle: 'solid'
        			}                    
                }, {
	                itemId: 'refreshSurveyData',
	        		action: 'refreshsurveydata',
	                text: 'Refresh Data',
	                iconCls: 'icon-refresh',
	    			cls:'x-btn-default-small',
	    			border: 1,
	    			style: {
	    			    borderColor: '#D1D1D1',
	    			    borderStyle: 'solid'
	    			} 
                }, {  
                	xtype: 'tbspacer'
                }, '->', {                	
                    xtype:'combo',                    
                    fieldLabel:'Search By',
                    name:'search_type',
                    queryMode:'local',
                    store:['Campaign Code','Region','Company Name'],
                    listeners: {
                        select: function(combo, records) {
                          Ext.getCmp('searchbyvalue').getStore().load({
                              params: {
                                param2: combo.getValue()
                              }
                          });  
                        }
                    },
                    displayField:'search_type',
                    autoSelect:true,
                    forceSelection:true
                 	
                }, {
                	xtype: 'combobox',
                	id:'searchbyvalue',
                	itemId: 'searchListField',
                	width: 200             	
                }, {
                	xtype: 'button',
                	text: 'Search',
                    tooltip: 'Click to start searching components',
                    itemId: 'searchInventoryData',
                    action: 'searchinventorydata',
                	iconCls: 'icon-zoom',
                	cls: 'x-btn-default-small',
        			border: 1,
        			style: {
        			    borderColor: '#D1D1D1',
        			    borderStyle: 'solid'
        			}        
                }]
	
		}, {
			xtype: 'pagingtoolbar',
			store: this.store, 
			dock: 'bottom',
			displayInfo: true			
		}];
        
        this.callParent(arguments);

	}

});