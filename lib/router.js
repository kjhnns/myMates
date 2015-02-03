Router.configure({
    // we use the  appBody template to define the layout for the entire app
    layoutTemplate: 'main',

    // the appNotFound template is used for unknown routes and missing lists
    // notFoundTemplate: 'appNotFound',

    // show the appLoading template whilst the subscriptions below load their data
    // loadingTemplate: 'appLoading',

    // wait on the following subscriptions before rendering the page to ensure
    // the data it's expecting is present
    // waitOn: function() {
    //   return [
    //     Meteor.subscribe('publicLists'),
    //     Meteor.subscribe('privateLists')
    //   ];
    // }
});


Router.map(function() {
    this.route('login', {
        path: '/login'
    });
    this.route('signup', {
        path: '/signup'
    });
    this.route('quotations', {
        path: '/quotations'
    });

    this.route('main', {
        path: '/',
        action: function() {
            Router.go('quotations');
        }
    });
});
