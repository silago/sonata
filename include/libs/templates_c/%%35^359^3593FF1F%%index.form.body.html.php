<?php /* Smarty version 2.6.16, created on 2014-03-04 17:30:25
         compiled from ru/modules/fb/index.form.body.html */ ?>
	<h2>Калькулятор</h2>
                <form action="?" method="post">
				<div class="box-cont">
					<div class="calc">
						<p>Для точного расчета стоимости нам нужно знать характеристики помещений. Специалисты нашей компании рассчитают стоимость работ и перезвонят Вам. Заявки на расчет стоимости обрабатываются в течении двух часов. </p>	

						<div class="calc-box">
							<h3>Основные данные</h3>
							<div class="block">
								<span>Имя <strong>*</strong></span>
								<input  name="cname" type="text" placeholder="Антон Антоныч" />	
							</div>	

							<div class="block">
								<span>Телефон <strong>*</strong></span>
								<input name="phone" type="text" placeholder="+7 (495) 456-24-23" />	
							</div>

							<div class="block">
								<span>E-Mail <strong>*</strong></span>
								<input name="email" type="text" placeholder="info@antinich.ru" class="alert-input" />	
								<p class="alert-text">Не корректно указан адрес электронной почты! <img src="/images/ln.png" height="10" width="3" alt="" /></p>
							</div>

							<div class="block">
								<span>Площадь объекта <strong>*</strong></span>
								<input name="Площадь" type="text" placeholder="" />	
							</div>
						</div>

						<div class="calc-box">
							<h3>Вид работ</h3>
							<div class="block">
								<label><input name="Вид работ" type="checkbox" class="niceCheck" /> Автоматическая пожарная сигнализация</label>
							</div>	

							<div class="block">
								<label><input name="Вид работ" type="checkbox" class="niceCheck" /> Охранная сигнализация</label>
							</div>

							<div class="block">
								<label><input name="Вид работ" type="checkbox" class="niceCheck" /> Система автоматического пожаротушения</label>
							</div>

							<div class="block">
								<label><input name="Вид работ" type="checkbox" class="niceCheck" /> Техническое Обслуживание</label>
							</div>
						</div>

						<div class="calc-box">
							<div class="block">
								<span>Кол-во помещений</span>
								<input name="Количество помещений" type="text" placeholder="" />
							</div>	

							<div class="block">
								<span>Кол-во выходов из здания</span>
								<input name="Количество выходов из здания" type="text" placeholder="" />
							</div>

							<div class="block">
								<span>Точный адрес объекта</span>
								<input name="Точный адрес объекта" type="text" placeholder="" />
							</div>

							<div class="block">
								<span>Высота и тип потолков</span>
								<input type="text" name="Высота и тип потолков" placeholder="" />
							</div>

							<div class="block">
								<span class="cm">Комментарий</span>
								<textarea name="message"></textarea>
							</div>

							<div class="block">
								<input type="submit" value="Отправить">
							</div>
						</div>
						</div>
					</div>	
                </form>