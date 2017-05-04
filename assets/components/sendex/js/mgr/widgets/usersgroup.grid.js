Sendex.grid.UsersGroup = function(config) {
	config = config || {};
	this.sm = new Ext.grid.CheckboxSelectionModel();

	Ext.applyIf(config,{
		id: 'sendex-grid-users_group'
		,url: Sendex.config.connector_url
		,baseParams: {
			action: 'mgr/usergroup/getlist'
		}
		,fields: ['id','name','description']
		,autoHeight: true
		,paging: true
		,remoteSort: true
		,sm: this.sm
		,columns: [
			{header: _('sendex_user_id'), sortable: true, dataIndex: 'id',width: 50}
			,{header: _('sendex_user_group_name'), sortable: true, dataIndex: 'name',width: 75}
			,{header: _('sendex_user_group_description'), sortable: true, dataIndex: 'description',width: 100}
		],
		tbar: [{
				text: '<i class="' + (MODx.modx23 ? 'icon icon-plus' : 'fa fa-plus') + '"></i> ' + _('sendex_user_group_btn_create'),
				handler: this.createUserGroup,
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

	Sendex.grid.UsersGroup.superclass.constructor.call(this, config);
};
Ext.extend(Sendex.grid.UsersGroup,MODx.grid.Grid, {
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

	,createUserGroup: function(btn,e) {
		if (!this.windows.createUserGroup) {
			this.windows.createUserGroup = MODx.load({
				xtype: 'sendex-window-user-group-create'
				,listeners: {
					'success': {fn:function() { this.refresh(); },scope:this}
				}
			});
		}
		this.windows.createUserGroup.fp.getForm().reset();
		this.windows.createUserGroup.show(e.target);
	}

});
Ext.reg('sendex-grid-users_group',Sendex.grid.UsersGroup);


Sendex.window.CreateUserGroup = function(config) {
	config = config || {};
	this.ident = config.ident || 'mecnewsletter'+Ext.id();
	Ext.applyIf(config,{
		title: _('sendex_user_group_create')
		,id: this.ident
		,autoHeight: true
		,width: 650
		,url: Sendex.config.connector_url
		,action: 'mgr/usergroup/create'
		,fields: [
			{xtype: 'textfield',fieldLabel: _('sendex_user_group_name'),name: 'name',id: 'sendex-'+this.ident+'-name',anchor: '100%'}
			,{xtype: 'textfield',fieldLabel: _('sendex_user_group_description'),name: 'description',id: 'sendex-'+this.ident+'-description',anchor: '100%'}
		]
		,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
	});
	Sendex.window.CreateUserGroup.superclass.constructor.call(this,config);
};
Ext.extend(Sendex.window.CreateUserGroup,MODx.Window);
Ext.reg('sendex-window-user-group-create',Sendex.window.CreateUserGroup);