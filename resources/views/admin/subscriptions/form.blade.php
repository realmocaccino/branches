{!! Form::select('user_id', $users, ['label' => 'Usuário', 'placeholder' => 'Selecione o usuário']) !!}

{!! Form::select('plan_id', $plans, ['label' => 'Plano', 'placeholder' => 'Selecione o plano da assinatura']) !!}

{!! Form::text('paid', ['label' => 'Preço pago', 'placeholder' => 'Insira o custo da assinatura']) !!}

{!! Form::text('expires_at', ['label' => 'Expira em', 'placeholder' => 'Insira a data de expiração da assinatura']) !!}
	
{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}