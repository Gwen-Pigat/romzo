export async function  handleSubmit(idForm, path){
    console.log(document.getElementById(idForm))
    let error = null
    let success = null
    const data = new FormData(document.getElementById(idForm))
    const response = await fetch(path, {
        method: 'POST',
        body: data
    });
    const result = await response.json();
    console.log(result.status, 200)
    if(result.data.error){
        error = result.data.error
    } else{
        success = result.data.message
    }
    if(result.data.url){
        let timer = 0
        if(result.data.url.timer){
            timer = result.data.url.timer
        }
        setTimeout(function(){
            window.location.href = result.data.url.value
        },timer);
    }
    return {error, success}
}