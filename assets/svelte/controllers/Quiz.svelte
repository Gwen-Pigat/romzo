<script>
 import Items from "./Items/Items.svelte";

 export let itemsSpecs
 export let paths

 let start = 0;
 let error = null

 let specs = []
 let results = []

 let defaultClass = "secondary"
 let activeClass = "contrast"

 async function addSpec(event) {
    event.currentTarget.setAttribute("disabled", "disabled")
    let newSpec = event.currentTarget.getAttribute("data-id")
    if(specs.indexOf(newSpec) === -1){
        specs.push(newSpec)
        event.currentTarget.classList.add(activeClass)
        event.currentTarget.classList.remove(defaultClass)
    } else{
        specs.splice(specs.indexOf(newSpec), 1)
        event.currentTarget.classList.remove(activeClass)
        event.currentTarget.classList.add(defaultClass)
    }
    event.currentTarget.removeAttribute("disabled")
 }

 async function validateQuiz(event)
 {
     let btnSubmit = event.currentTarget
     console.log("Validate",specs, btnSubmit.getAttribute("data-path"))
     //btnSubmit.setAttribute("aria-busy", true)
     const data = new FormData()
     data.append("specs", specs)
     const response = await fetch(event.currentTarget.getAttribute("data-path"), {
         method: 'POST',
         body: data
     });
     const result = await response.json();
     console.log(event.currentTarget)
     //btnSubmit.removeAttribute("aria-busy")
     if(result.data.error){
        error = result.data.error
     }
     if(result.data.items){
         results = result.data.items
     }
     console.log(result)
 }

 const restartQuiz = () =>{
     results = []
     specs = []
 }

</script>

<div class="quiz">
    {#if results.length > 0}
        <button on:click={restartQuiz}>Recommencer</button>
        <div id="results">
            {#each results as item}
                <Items {item} {paths} />
            {/each}
        </div>
    {:else if itemsSpecs}
        <h2>Veuillez cliquer sur le ou les critère(s) qui vous intéressent</h2>
        {#each itemsSpecs as itemSpec}
            <button type="button" class="{defaultClass} item" data-id="{itemSpec.id}" on:click={addSpec}>
                {itemSpec.name}
            </button>
        {/each}
        <button class="primary submit" on:click={validateQuiz} data-path="{paths.validateQuiz}">Finir le quiz</button>
        {#if error}
            <div class="warning">{error}</div>
        {/if}
    {/if}
</div>

<style>
    .quiz .item{
        display: inline-block;
        width: auto;
        margin: 0.4rem;
    }
    .submit{
        margin-top: 2rem;
    }
</style>