{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira o nome do plano']) !!}

{!! Form::text('price', ['label' => 'Preço', 'placeholder' => 'Insira o preço do plano']) !!}

{!! Form::text('days', ['label' => 'Dias', 'placeholder' => 'Insira a quantidade de dias de vigência']) !!}
	
{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}