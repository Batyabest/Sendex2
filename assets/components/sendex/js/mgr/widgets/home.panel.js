Sendex.panel.Home = function(config) {
	config = config || {};
	Ext.apply(config,{
		border: false
		,baseCls: 'modx-formpanel'
		,layout: 'anchor'
		,items: [{
			html: '<h2>'+_('sendex')+'</h2>'
			,border: false
			,cls: 'modx-page-header container'
		},{
			xtype: 'modx-tabs'
			,defaults: { border: false ,autoHeight: true }
			,border: true
			,stateful: true
			,stateId: 'sendex-panel-home'
			,stateEvents: ['tabchange']
			,getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};}
			,hideMode: 'offsets'
			,items: [{
				title: _('sendex_newsletters')
				,layout: 'anchor'
				,items: [{
					html: _('sendex_newsletters_intro')
					,border: false
					,bodyCssClass: 'panel-desc'
				},{
					xtype: 'sendex-grid-newsletters'
					,cls: 'main-wrapper'
					,preventRender: true
				}]
			},{
				title: _('sendex_queues')
				,layout: 'anchor'
				,items: [{
					html: _('sendex_queue_intro')
					,border: false
					,bodyCssClass: 'panel-desc'
				},{
					xtype: 'sendex-grid-queues'
					,cls: 'main-wrapper'
					,preventRender: true
				}]
			},{
				title: _('sendex_users')
				,layout: 'anchor'
				,items: [{
					html: _('sendex_user_intro')
					,border: false
					,bodyCssClass: 'panel-desc'
				},{
					xtype: 'sendex-grid-users'
					,cls: 'main-wrapper'
					,preventRender: true
				}]
			},{
				title: _('sendex_users_group')
				,layout: 'anchor'
				,items: [{
					html: _('sendex_user_group_intro')
					,border: false
					,bodyCssClass: 'panel-desc'
				},{
					xtype: 'sendex-grid-users_group'
					,cls: 'main-wrapper'
					,preventRender: true
				}]
			}]
		}]
	});
	Sendex.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(Sendex.panel.Home,MODx.Panel);
Ext.reg('sendex-panel-home',Sendex.panel.Home);
