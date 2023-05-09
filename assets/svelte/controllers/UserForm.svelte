<script>
    export let fields
    export let path

    let error = null
    let success = null

    async function handleSubmit(event){
        let btnSubmit = null;
        if(event.currentTarget.getAttribute("data-submit") !== undefined){
            btnSubmit = document.getElementById(event.currentTarget.getAttribute("data-submit"))
            btnSubmit.setAttribute("aria-busy","true")
        }
        const data = new FormData(this)
        const response = await fetch(event.currentTarget.getAttribute("data-path"), {
            method: 'POST',
            body: data
        });
        const result = await response.json();
        if(btnSubmit !== null){
            btnSubmit.removeAttribute("aria-busy")
        }
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
    }
    $: {
        error;
        console.log(error)
    }

</script>

<h1>Connectez-vous à votre espace</h1>
{#if success !== null}
    <div class="success">{success}</div>
{:else}
    <form on:submit|preventDefault={handleSubmit} data-path="{path}" data-submit="setLoginBtn">
        {#if !fields}
            AUcun champ n'a pu être récupéré
        {/if}
        {#each fields as field}
            {@html field}
        {/each}
        <button id="setLoginBtn" type="submit">Me connecter</button>

        {#if error !== null}
            <div class="warning">{error}</div>
        {/if}
    </form>
{/if}