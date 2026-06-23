<style>
form
{
    height:100%;
    width: 100%;
    background-color: #4b4b4b!important;
}
.terminal {
  background-color: #333!important;
  color: #fff!important;
  font-family: monospace!important;
  border-radius: 5px!important;
  padding: 20px!important;
}

.prompt {
  display: inline-block!important;
  margin-right: 10px!important;
  font-size:25px;
}

.input {
  background-color: transparent!important;
  border: none!important;
  color: #fff!important;
  font-family: monospace!important;
  width: calc(100% - 40px)!important;
}
.green
{
    color:lime;
}
.yellow
{
    color:#ffcb00;
}

.red
{
    color:#ff5151;
}
</style>
 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight laos">
            {{ __('LOG') }}
            is_admin : {{auth()->user()->is_admin}}
        </h2>
    </x-slot> 
    <form>
        <div class="terminal">
            @foreach ($log as $ls)
                <div class="prompt"><asd class="yellow">$</asd>  <small> {{ $ls->time}} {{ date('d-m-Y',strtotime($ls->date))}}</small> <asd class="green">{{ $ls->name}}</asd>  ><asd class="@if($ls->pointer=='CheckingEnter & Cancel') red @endif"> {{ $ls->feed_back_msg}}</asd>.</div>
                <br><br>  
            @endforeach
        </div> 
    </form> 
 
