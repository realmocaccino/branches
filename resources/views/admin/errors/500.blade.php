@layout('layout.estrutura')

@section('conteudo')

	<div class="container">
		<div id="info">
			<p>{{ Admin::voltar('/') }}</p>
		</div>
		{{ Admin::mensagem('Algo deu errado', 'warning') }}
	</div>

@endsection
