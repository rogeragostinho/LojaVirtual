<!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                        <path
                            d="M160-280v80h640v-80H160Zm0-440h88q-5-9-6.5-19t-1.5-21q0-50 35-85t85-35q30 0 55.5 15.5T460-826l20 26 20-26q18-24 44-39t56-15q50 0 85 35t35 85q0 11-1.5 21t-6.5 19h88q33 0 56.5 23.5T880-640v440q0 33-23.5 56.5T800-120H160q-33 0-56.5-23.5T80-200v-440q0-33 23.5-56.5T160-720Zm0 320h640v-240H596l84 114-64 46-136-184-136 184-64-46 82-114H160v240Zm200-320q17 0 28.5-11.5T400-760q0-17-11.5-28.5T360-800q-17 0-28.5 11.5T320-760q0 17 11.5 28.5T360-720Zm240 0q17 0 28.5-11.5T640-760q0-17-11.5-28.5T600-800q-17 0-28.5 11.5T560-760q0 17 11.5 28.5T600-720Z" />
                    </svg>
                    Novo produto
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.produto.store')}}" method="POST" enctype="multipart/form-data" >
                <div class="modal-body">

                    @csrf
                    <input type ="hidden" name="id_user" value="{{auth()->user()->id}}">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="nome" placeholder="fe" required>
                        <label for="floatingInput">Nome</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" name="preco" placeholder="fef" required>
                        <label for="floatingInput">Preço</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="descricao" placeholder="gr" required>
                        <label for="floatingInput">Descrição</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" name="id_categoria" aria-label="Floating label select example" required>
                            <option selected>Escolha uma opcao</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                        <label for="floatingSelect">Categoria</label>
                    </div>
                    <div class="mb-3">
                      <input type="file" name="imagem" class="form-control" required>
                      
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
