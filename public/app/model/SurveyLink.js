Ext.define("Estore.model.SurveyLink", {
    extend: 'Ext.data.Model',    
    fields: [
              { name: 'link_id', type: 'int' },
	          { name: 'campaign_name', type: 'string' },
	          { name: 'created_by', type: 'string' },
	          { name: 'date_created', type: 'string' },
	          { name: 'survey_url', type: 'string' }
             ]
});