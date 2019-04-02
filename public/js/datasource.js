class  DataSource{
    
    constructor(){
        this.token = document.querySelector('input[name=_token]').value;
    }

    async get(url){
        let response = await fetch(url,{
            headers: {
                "X-CSRF-TOKEN": this.token,
            }});
        let data = await response.json();
        return data;
    }

    async post(url,formData){

        let response = await fetch(url,{
            method:'POST',
            headers: {
                "X-CSRF-TOKEN": this.token,
            },
            body:formData,
        })
        let data = await response.json();
        return data;
    }

    async put(url,formData){
        let response = await fetch(url,{
            method:'POST',
            headers: {
                "X-CSRF-TOKEN": this.token,
            },
            body:formData,
        })
        let data = await response.json();
        return data;
    }

    async delete(url){
        let response = await fetch(url,{
            method:'DELETE',
            headers: {
                "X-CSRF-TOKEN": this.token,
            }
        })
        let data = await response.json();
        return data;

    }
}