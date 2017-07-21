Sendex.grid.UnsubscribeQuestion = function(config) {
	config = config || {};
	this.sm = new Ext.grid.CheckboxSelectionModel();

	Ext.applyIf(config,{
		id: 'sendex-grid-unsubscribe_question'
		,url: Sendex.config.connector_url
		,baseParams: {
			action: 'mgr/unsubscribes/getlist'
		}
		,fields: ['id','question','description']
		,autoHeight: true
		,paging: true
		,remoteSort: true
		,sm: this.sm
		,columns: [
			{header: _('sendex_unsubscribe_question_id'), sortable: true, dataIndex: 'id',width: 50}
			,{header: _('sendex_unsubscribe_question_question'), sortable: true, dataIndex: 'question',width: 75}
			,{header: _('sendex_unsubscribe_question_description'), sortable: true, dataIndex: 'description',width: 100}
		],
		tbar: [{
				text: '<i class="' + (MODx.modx23 ? 'icon icon-plus' : 'fa fa-plus') + '"></i> ' + _('sendex_unsubscribe_question_create'),
				handler: this.createUnsubscribeQuestion,
				scope: this
			}
		]
		/*
		 listeners: {
		 	rowDblClick: function(grid, rowIndex, e) {
		 		var row = grid.store.getAt(rowIndex);
		 		this.update(grid, e, row);
		 	}
		 }
		 */
	});

	Sendex.grid.UnsubscribeQuestion.superclass.constructor.call(this, config);
};
Ext.extend(Sendex.grid.UnsubscribeQuestion,MODx.grid.Grid, {
	windows: {}

	,getMenu: function(grid, rowIndex) {
		var row = grid.getStore().getAt(rowIndex);
		var menu = Sendex.utils.getMenu(row.data.actions, this);
		this.addContextMenuItem(menu);
	}

	,onClick: function(e) {
		var elem = e.getTarget();
		if (elem.nodeName == 'BUTTON') {
			var row = this.getSelectionModel().getSelected();
			if (typeof(row) != 'undefined') {
				var type = elem.getAttribute('type');
				if (type == 'menu') {
					var ri = this.getStore().find('id', row.id);
					return this._showMenu(this, ri, e);
				}
				else {
					this.menu.record = row.data;
					return this[type](this, e);
				}
			}
		}
		return this.processEvent('click', e);
	}

	,createUnsubscribeQuestion: function(btn,e) {
		if (!this.windows.createUnsubscribeQuestion) {
			this.windows.createUnsubscribeQuestion = MODx.load({
				xtype: 'sendex-window-unsubscribe_question-create'
				,listeners: {
					'success': {fn:function() { this.refresh(); },scope:this}
				}
			});
		}
		this.windows.createUnsubscribeQuestion.fp.getForm().reset();
		this.windows.createUnsubscribeQuestion.show(e.target);
	}

});
Ext.reg('sendex-grid-unsubscribe_question',Sendex.grid.UnsubscribeQuestion);


Sendex.window.CreateUnsubscribeQuestion = function(config) {
	config = config || {};
	this.ident = config.ident || 'mecnewsletter'+Ext.id();
	Ext.applyIf(config,{
		title: _('sendex_unsubscribe_question_create')
		,id: this.ident
		,autoHeight: true
		,width: 650
		,url: Sendex.config.connector_url
		,action: 'mgr/unsubscribes/create'
		,fields: [
			{xtype: 'textfield',fieldLabel: _('sendex_unsubscribe_question_question'),name: 'question',id: 'sendex-'+this.ident+'-question',anchor: '100%'}
			,{xtype: 'textfield',fieldLabel: _('sendex_unsubscribe_question_description'),name: 'description',id: 'sendex-'+this.ident+'-description',anchor: '100%'}
		]
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	Sendex.window.CreateUnsubscribeQuestion.superclass.constructor.call(this,config);
};
Ext.extend(Sendex.window.CreateUnsubscribeQuestion,MODx.Window);
Ext.reg('sendex-window-unsubscribe_question-create',Sendex.window.CreateUnsubscribeQuestion);