<?php
/*
 *  EOPHP2 - A modular bot for EO
 *  Copyright (C) 2017  bloski
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
class EOPHPModule {
    protected $bot;
    protected $module_name;
    protected $init_time;
    protected $verbose;

    final function __construct($bot, $args = []) {
        $this->bot = $bot;
        $this->module_name = get_called_class();
        $this->init_time = time();
        $this->verbose = defined('VERBOSE') && VERBOSE;

        $this->Initialize($args);
    }

    final function __destruct() {
        $this->Uninitialize();
    }

    function Initialize($args) {

    }

    function Uninitialize() {

    }

    function Tick() {

    }

    final protected function Output($out) {
        echo "[".date("H:i:s")."] [".$this->bot->get_host().'::'.$this->module_name."] $out\n";
    }

    final public function Login($username, $password) {
        $this->bot->send_packet(Protocol::F['Login'], Protocol::A['Request'], [
            $username,
            Protocol::COMMA,
            $password, Protocol::COMMA
        ]);
    }

    final public function SelectCharacter($id) {
        $this->bot->send_packet(Protocol::F['Welcome'], Protocol::A['Request'], [
            Protocol::EncodeInteger($id, 4)
        ]);
    }

    final public function WorldLogin($player_id, $character_id) {
        $this->bot->send_packet(Protocol::F['Welcome'], Protocol::A['Message'], [
            Protocol::EncodeInteger($player_id, 3),
            Protocol::EncodeInteger($character_id, 4)
        ]);
    }

    final public function Emote($emote) {
        $this->bot->send_packet(Protocol::F['Emote'], Protocol::A['Report'], [
            Protocol::EncodeInteger($emote, 1)
        ]);
    }

    final public function Say($message) {
        $this->bot->send_packet(Protocol::F['Talk'], Protocol::A['Report'], [
            $message
        ]);
    }

    final public function PrivateMessage($to, $message) {
        $this->bot->send_packet(Protocol::F['Talk'], Protocol::A['Tell'], [
            $to,
            Protocol::COMMA,
            $message]);
    }

    final public function Latency() {
        $this->bot->send_packet(Protocol::F['Message'], Protocol::A['Ping'], [
            Protocol::EncodeInteger(2, 2)
        ]);
    }

    final public function Face($direction) {
        $this->bot->send_packet(Protocol::F['Face'], Protocol::A['Player'], [
            Protocol::EncodeInteger($direction, 1)
        ]);
    }

    final public function get_name() {
        return $this->module_name;
    }

    final public function get_init_time() {
        return $this->init_time;
    }
}
