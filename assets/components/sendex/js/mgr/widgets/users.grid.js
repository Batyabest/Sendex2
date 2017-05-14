Sendex.grid.Users = function(config) {
	config = config || {};
	this.sm = new Ext.grid.CheckboxSelectionModel();

	Ext.applyIf(config,{
		id: 'sendex-grid-users'
		,url: Sendex.config.connector_url
		,baseParams: {
			action: 'mgr/user/getlist',
			name: config.name
		}
		,fields: ['id','email','name','status']
		,autoHeight: true
		,paging: true
		,remoteSort: true
		,sm: this.sm
		,columns: [
			{header: _('sendex_user_id'), sortable: true, dataIndex: 'id',width: 50}
			,{header: _('sendex_user_email'), sortable: true, dataIndex: 'email',width: 75}
			,{header: _('sendex_user_group'), sortable: true, dataIndex: 'name',width: 100}
			,{header: _('sendex_user_status'), sortable: false, dataIndex: 'status',width: 100}
		],
		tbar: [{
				text: '<i class="' + (MODx.modx23 ? 'icon icon-plus' : 'fa fa-plus') + '"></i> ' + _('sendex_user_btn_create'),
				handler: this.createUser,
				scope: this
			},{
			text: '<i class="' + (MODx.modx23 ? 'icon icon-upload-alt' : 'fa fa-upload') + '"></i> ' + _('sendex_import_user_btn_create'),
			handler: this.importUser,
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

	Sendex.grid.Users.superclass.constructor.call(this, config);
};
Ext.extend(Sendex.grid.Users,MODx.grid.Grid, {
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

	,createUser: function(btn,e) {
		if (!this.windows.createUser) {
			this.windows.createUser = MODx.load({
				xtype: 'sendex-window-user-create'
				,listeners: {
					'success': {fn:function() { this.refresh(); },scope:this}
				}
			});
		}
		this.windows.createUser.fp.getForm().reset();
		this.windows.createUser.show(e.target);
	}

	,importUser: function(btn,e) {
		if (!this.windows.importUser) {
			this.windows.importUser = MODx.load({
				xtype: 'sendex-window-import-user-create'
				,listeners: {
					'success': {fn:function() { this.refresh(); },scope:this}
				}
			});
		}
		this.windows.importUser.fp.getForm().reset();
		this.windows.importUser.show(e.target);
	}

	,updateUser: function(btn,e,row) {
		return true;
	}

	,sendUser: function(btn,e,row) {
		var ids = this._getSelectedIds();
		if (!ids) {return;}
		Sendex.utils.onAjax(this.getEl());

		MODx.Ajax.request({
			url: Sendex.config.connector_url
			,params: {
				action: 'mgr/user/send'
				,ids: ids.join(',')
			}
			,listeners: {
				success: {fn:function(r) {this.refresh();},scope:this}
			}
		});
	}

	,removeUser: function(btn,e,row) {
		var ids = this._getSelectedIds();
		if (!ids) {return;}

		MODx.msg.confirm({
			title: _('sendex_queues_remove')
			,text: _('sendex_queues_remove_confirm')
			,url: Sendex.config.connector_url
			,params: {
				action: 'mgr/queue/remove'
				,ids: ids.join(',')
			}
			,listeners: {
				success: {fn:function(r) {this.refresh();},scope:this}
			}
		});
	}

	,sendAll: function() {
		Sendex.utils.onAjax(this.getEl());

		MODx.msg.confirm({
			title: _('sendex_users_send_all')
			,text: _('sendex_users_send_all_confirm')
			,url: Sendex.config.connector_url
			,params: {
				action: 'mgr/user/send_all'
			},
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		});
	},

	removeAll: function() {
		Sendex.utils.onAjax(this.getEl());

		MODx.msg.confirm({
			title: _('sendex_queues_remove_all'),
			text: _('sendex_queues_remove_all_confirm'),
			url: Sendex.config.connector_url,
			params: {
				action: 'mgr/user/remove_all'
			},
			listeners: {
				success: {
					fn: function () {
						this.refresh();
					}, scope: this
				}
			}
		});
	}

	,_getSelectedIds: function() {
		var ids = [];
		var selected = this.getSelectionModel().getSelections();

		for (var i in selected) {
			if (!selected.hasOwnProperty(i)) {continue;}
			ids.push(selected[i]['id']);
		}

		return ids;
	}

});
Ext.reg('sendex-grid-users',Sendex.grid.Users);


Sendex.window.CreateUser = function(config) {
	config = config || {};
	this.ident = config.ident || 'mecnewsletter'+Ext.id();
	Ext.applyIf(config,{
		title: _('sendex_user_create')
		,id: this.ident
		,autoHeight: true
		,width: 650
		,url: Sendex.config.connector_url
		,action: 'mgr/user/create'
		,fields: [
			{xtype: 'textfield',fieldLabel: _('sendex_user_email'),name: 'email',id: 'sendex-'+this.ident+'-email',anchor: '100%'}
			,{xtype: 'sendex-combo-usergroupsx',fieldLabel: _('sendex_user_group'),name: 'usergroup_id',id: 'sendex-'+this.ident+'-usergroup_id',anchor: '100%'}
		]
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	Sendex.window.CreateUser.superclass.constructor.call(this,config);
};
Ext.extend(Sendex.window.CreateUser,MODx.Window);
Ext.reg('sendex-window-user-create',Sendex.window.CreateUser);


Sendex.window.ImportUser = function(config) {
	config = config || {};
	this.ident = config.ident || 'mecnewsletter'+Ext.id();
	Ext.applyIf(config,{
		title: _('sendex_user_create')
		,id: this.ident
		,autoHeight: true
		,width: 650
		,url: Sendex.config.connector_url
		,action: 'mgr/user/import'
		,fields: [
				{xtype: 'modx-combo-browser',fieldLabel: _('sendex_user_import_file'),name: 'import_source',id: 'sendex-'+this.ident+'-import_source',anchor: '100%'}
				,{xtype: 'sendex-combo-usergroupsx',fieldLabel: _('sendex_user_group'),name: 'usergroup_id',id: 'sendex-'+this.ident+'-usergroup_id',anchor: '100%'}
			]
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	Sendex.window.ImportUser.superclass.constructor.call(this,config);
};

Ext.extend(Sendex.window.ImportUser,MODx.Window);
Ext.reg('sendex-window-import-user-create',Sendex.window.ImportUser);