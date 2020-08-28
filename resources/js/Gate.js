export default class Gate {
    constructor(user) {
        this.user = user;
    }
    isAdmin(){
        return this.user.role === 'admin';
    }
    isSupreme(){
        return this.user.role === 'supreme';
    }
    isUser(){
        return this.user.role === 'user';
    }
    isProjectmanager(){
        return this.user.role === 'project_manager';
    }
    isDeveloper(){
        return this.user.role === 'developer';
    }
    isAdminOrisProjectmanager(){
        if(this.user.role === 'admin' || this.user.role === 'project_manager'){
            return true;
        }
    };

}
