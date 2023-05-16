# coding: utf-8

from __future__ import absolute_import

from flask import json
from six import BytesIO

from swagger_server.models.login_body import LoginBody  # noqa: E501
from swagger_server.models.new_password import NewPassword  # noqa: E501
from swagger_server.models.token import Token  # noqa: E501
from swagger_server.models.user import User  # noqa: E501
from swagger_server.test import BaseTestCase


class TestDefaultController(BaseTestCase):
    """DefaultController integration test stubs"""

    def test_change_password_put(self):
        """Test case for change_password_put

        Altera senha do usuário autenticado
        """
        body = NewPassword()
        response = self.client.open(
            '/api/v1/change_password',
            method='PUT',
            data=json.dumps(body),
            content_type='application/json')
        self.assert200(response,
                       'Response body is : ' + response.data.decode('utf-8'))

    def test_login_post(self):
        """Test case for login_post

        Realiza login e retorna token de acesso
        """
        body = LoginBody()
        response = self.client.open(
            '/api/v1/login',
            method='POST',
            data=json.dumps(body),
            content_type='application/json')
        self.assert200(response,
                       'Response body is : ' + response.data.decode('utf-8'))

    def test_register_post(self):
        """Test case for register_post

        Registra novo usuário
        """
        body = User()
        response = self.client.open(
            '/api/v1/register',
            method='POST',
            data=json.dumps(body),
            content_type='application/json')
        self.assert200(response,
                       'Response body is : ' + response.data.decode('utf-8'))

    def test_verify_token_get(self):
        """Test case for verify_token_get

        Verifica se o token de acesso é válido
        """
        response = self.client.open(
            '/api/v1/verify_token',
            method='GET')
        self.assert200(response,
                       'Response body is : ' + response.data.decode('utf-8'))

    def test_identify_token_get(self):
        """Test case for identify_token_get

        Retorna o id associado ao token de acesso
        """
        response = self.client.open(
            '/api/v1/identify_token',
            method='GET')
        self.assert200(response,
                       'Response body is : ' + response.data.decode('utf-8'))

if __name__ == '__main__':
    import unittest
    unittest.main()
